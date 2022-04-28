const cheerio = require("cheerio");

const errorString = "Could not find";

const cleanString = cleanThis => {
  return cleanThis.replace(/\t|\n/gm, '');
}

const addBaseUrl = (url, baseUrl) => {
  const needsBase = url.indexOf('http');
  const newUrl = needsBase <= 0 ? `${baseUrl}${url}` : url;

  return newUrl | "something went wrong";
}

const getArticleTitle = (titleSelect) => {
  const dirtyTitle = titleSelect.text();
  const title = cleanString(dirtyTitle);

  return title[0] | `${errorString} title.`
}

const getArticleDescription = (articleSelect, selector) => {
  const dirtyDescription = articleSelect.find(selector).text();
  const description = cleanString(dirtyDescription);

  return description | `${errorString} description.`;
}

const getArticleUrl = async (titleSelect, baseUrl) => {
  const titleHref = titleSelect.attr('href');
  const url = await addBaseUrl(titleHref, baseUrl);

  return url | `${errorString} url.`;
}

const getArticleAuthor = () => {}
const getArticlePublishedDate = () => {}
const getArticleImgSource = () => {}
const getArticleImgAlt = () => {}

const getSiteIcon = async (site, $, html) => {
  const siteIconHref = $(site.selectors.siteIcon, html).attr('href');
  const siteIcon = await addBaseUrl(siteIconHref, site.baseUrl);
  
  return siteIcon | `${errorString} site icon.`;
}

const scrapeForArticles = async (site, html) => {
  const articles = [];
  const $ = cheerio.load(html);

  const siteIcon = getSiteIcon(site, $, html)
  
  $(site.selectors.article, html).each(async function() {
    const article = $(this)
    const titleSelect = $(this).find(site.selectors.title);
    
    const title = await getArticleTitle(titleSelect);
    
    const url = await getArticleUrl(titleSelect, site.baseUrl);
    
    const author = $(this).find(site.selectors.author).text();

    const publishedDate = $(this).find(site.selectors.date).text();

    let imgSrc = $(this).find(site.selectors.image).attr('data-src');
    imgSrc = imgSrc || $(this).find(site.selectors.image).attr('src');
    const source = addBaseUrl(imgSrc, site.baseUrl);
    const imgAlt = $(this).find(site.selectors.image).attr('alt');
    
    const description = getArticleDescription(article, site.selectors.description);

    // TODO: TS would be nice for this.
    articles.push({
      siteId: site.id,
      title,
      description,
      url,
      publishedDate,
      author,
      image: {
        source,
        alt: imgAlt,
      },
      siteIcon,
      displayName: site.displayName,
    });
  });
  console.log("scraped articles array: ", {articles})
  return articles;
};

module.exports = scrapeForArticles;
