const functions = require("firebase-functions");
const cors = require("cors")({ origin: true })

const cheerio = require("cheerio");
const axios = require("axios");

// // Create and Deploy Your First Cloud Functions
// // https://firebase.google.com/docs/functions/write-firebase-functions
//
// exports.helloWorld = functions.https.onRequest((request, response) => {
//   functions.logger.info("Hello logs!", {structuredData: true});
//   response.send("Hello from Firebase!");
// });
const sites = [
  // {
  //   url: "https://www.asphaltandrubber.com",
  //   titleSelector: ".post-title-alt",
  //   postDescriptionClassName: ".post-content",
      // baseUrl: ""
  // },
  // {
  //   url: "https://www.motorcyclenews.com",
  //   titleSelector: ".home__featured-stories__story",
  //   postDescriptionClassName: "",
  //   baseUrl: "https://www.motorcyclenews.com"
  // },
  // {
  //   url: "https://www.cycleworld.com",
  //   titleSelector: ".headline",
  //   postDescriptionClassName: ".subtitle",
  //   baseUrl: "https://www.cycleworld.com"
  // },
  // {
  //   url: "https://www.motorcyclistonline.com",
  //   titleSelector: ".headline",
  //   postDescriptionClassName: ".subtitle",
  //   baseUrl: "https://www.motorcyclistonline.com"
  // },
  // {
  //   url: "https://www.motorcycle.com",
  //   titleSelector: "article",
  //   postDescriptionClassName: "",
  //   baseUrl: ""
  // },
  {
    url: "https://www.motorcycle.com",
    titleSelector: "h3",
    postDescriptionClassName: "",
    baseUrl: "https://www.motorcycle.com"
  },
];

const scrapeMetatags = () => {
  const articles = [];
  const requests = sites.map(async site => {

      const response = await axios  (site.url);
      const html = response.data;
      const $ = cheerio.load(html);
      // need to find all the titles
      
      $(site.titleSelector, html).each(function() {
        const title = $(this).text();
        const url = $(this).find('a').attr('href')
        articles.push({
          title,
          url: `${site.baseUrl}${url}`,
        })
      })
      

      // const articleList = { 
      //     baseUrl: site.url,
      //     siteTitle: $('title').first().text(),
      //     favicon: $('link[rel="shortcut icon"]').attr('href'),
      //     articleTitles: "",
      //     description: "",
      //     image: "",
      //     author: "",
      // }
      // console.log(articleList);
      console.log(articles);
      return articles;
  });


  return Promise.all(requests);

}
scrapeMetatags();
console.log("End all things");
