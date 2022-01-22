const PORT = process.env.PORT || 8093
const express = require('express')
const cors = require("cors")({ origin: true })

const cheerio = require("cheerio");
const axios = require("axios");

const app = express()

const sites = [
  {
    url: "https://www.asphaltandrubber.com",
    titleSelector: ".post-title-alt",
    postDescriptionClassName: ".post-content",
      baseUrl: ""
  },
  {
    url: "https://www.motorcyclenews.com",
    titleSelector: ".home__featured-stories__story",
    postDescriptionClassName: "",
    baseUrl: "https://www.motorcyclenews.com"
  },
  {
    url: "https://www.cycleworld.com",
    titleSelector: ".headline",
    postDescriptionClassName: ".subtitle",
    baseUrl: "https://www.cycleworld.com"
  },
  {
    url: "https://www.motorcyclistonline.com",
    titleSelector: ".headline",
    postDescriptionClassName: ".subtitle",
    baseUrl: "https://www.motorcyclistonline.com"
  },
  {
    url: "https://www.motorcycle.com",
    titleSelector: "h3",
    postDescriptionClassName: "",
    baseUrl: ""
  },
];

const articles = [];

const cleanString = cleanThis => {
    return cleanThis.replace(/\t|\n/gm, '');
};

sites.forEach(site => {
  axios.get(site.url)
    .then(response => {
      const html = response.data;
      const $ = cheerio.load(html);
      
      $(site.titleSelector, html).each(function() {
        const dirtyTitle = $(this).text();
        const cleanTitle = cleanString(dirtyTitle);

        const url = $(this).find('a').attr('href');
        articles.push({
          title: cleanTitle,
          url: `${site.baseUrl}${url}`,
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
