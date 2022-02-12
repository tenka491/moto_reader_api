const PORT = process.env.PORT || 8093
const express = require('express')
const cors = require("cors")({ origin: true })

const cheerio = require("cheerio");
const axios = require("axios");
const sites = require("./sites")

const app = express()

const articles = [];

const cleanString = cleanThis => {
    return cleanThis.replace(/\t|\n/gm, '');
};

sites.forEach(site => {
  axios.get(site.url)
    .then(response => {
      const html = response.data;
      const $ = cheerio.load(html);
      
      // TODO: switch this to the Article Selector
      $(site.selectors.title, html).each(function() {
        const dirtyTitle = $(this).text();
        const cleanTitle = cleanString(dirtyTitle);

        const url = $(this).find('a').attr('href');
        articles.push({
          siteId: site.id,
          title: cleanTitle,
          description: "",
          url: `${site.baseUrl}${url}`,
          publishedDate: "",
          author: "",
          image: {
            source: "",
            alt: "",
          },
          siteIcon: "",
          displayName: site.displayName,
        });
      });
    });
});

app.get('/', (request, response) => {
  response.json('Welcome to the moto-reader-api');
});

app.get('/articles', (request, response) => {
  response.json(articles);
});

app.listen(PORT, () => console.log(`server running on PORT ${PORT}`));
