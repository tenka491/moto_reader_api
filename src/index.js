const PORT = process.env.PORT || 8093
const express = require('express')
const cors = require("cors")({ origin: true })

const axios = require("axios");
const sites = require("./sites")
const srcType = require("./utils/srcTypes")
const scrapeForArticles = require("./utils/scrapper")
const app = express()

const articles = [];

const extractArticles = async (site, feedSource) => {
  let extractedRss;
  let extractedScraped;

  if (site.srcType === srcType.rss) {
    // TODO: go to rss extractor
    extractedRss = [ {name: "something goes here"}]
    console.log("rss: ", {extractedRss})

    articles.concat(extractedRss);
  }
  if (site.srcType === srcType.html) {
    extractedScraped = await scrapeForArticles(site, feedSource);
    console.log("scraped: ", {extractedScraped})

    articles.concat(extractedScraped);
  }

  console.log("extractArticles: ", {articles})
}

sites.forEach(site => {
  axios.get(site.url)
    .then(async response => {
      const feedSource = await response.data;
      await extractArticles(site, feedSource);
    }).catch((error)=>{return "An error occurred while trying to collect data, please try again later."});
});

app.get('/', (request, response) => {
  response.json('Welcome to the moto-reader-api');
});

app.get('/articles', (request, response) => {
  response.json(articles);
});

app.listen(PORT, () => console.log(`server running on PORT ${PORT}`));
