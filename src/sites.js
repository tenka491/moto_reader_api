const srcType = require("./utils/srcTypes")

const sites = [
  {
    id: 0,
    url: "https://www.asphaltandrubber.com/feed/",
    srcType: srcType.rss,
     displayName: "Asphalt and Rubber",
    baseUrl: "",
    selectors: {
      article: "article",
      title: "h2 > a",
      postDescription: ".post-content",
      image: ".featured img",
      author: ".post-author",
      date: ".post-date",
      siteIcon:"[rel=icon]"
    }
  },
  {
    id: 1,
    url: "https://www.motorcyclenews.com/news/",
   srcType: srcType.html, 
   displayName: "Motorcycle News",
    baseUrl: "https://www.motorcyclenews.com",
    selectors: {
      article: ".article-landing__article",
      title: ".article-landing__article__heading a",
      postDescription: "p:last",
      image: ".thumbnail",
      author: ".article-landing__article__info__author",
      date: ".article-landing__article__info__date",
      siteIcon:"[rel='shortcut icon']"
    }
  },
  // NOTE: Cycleworld uses an IFrame!
  // {
  //   id: 2,
  //   url: "https://www.cycleworld.com/tags/motorcycle-news/",
  //  srcType: srcType.rss, 
  //  displayName: "Cycle World",
  //   baseUrl: "https://www.cycleworld.com",
  //   selectors: {
  //     article: ".flex-feature",
  //     title: ".feature-listing > .headline",
  //     postDescription: ".subtitle",
  //     image: "",
  //     author: ".byline a",
  //     date: ".byline span:last",
  //     siteIcon:""
  //   }
  // },
  // {
  //   id: 3,
  //   url: "https://www.motorcyclistonline.com/motorcycle-news/",
  //  srcType: srcType.rss, 
  //  displayName: "Motorcyclist Online",
  //   baseUrl: "https://www.motorcyclistonline.com",
  //   selectors: {
  //     article: ".flex-feature .container",
  //     title: ".feature-listing > .headline",
  //     postDescription: ".subtitle",
  //     image: "",
  //     author: "",
  //     date: "",
  //     siteIcon:""
  //   }
  // },
  // {
  //   id: 4,
  //   url: "https://blog.motorcycle.com/",
  //  srcType: srcType.rss, 
  //  displayName: "Motorcycle.com",
  //   baseUrl: "",
  //   selectors: {
  //     article: "article.text_wrapper",
  //     title: ".text .main-column-text > h3 > a",
  //     postDescription: ".main-column-text-wrapper > p",
  //     image: "a.lazyloaded",
  //     author: "",
  //     date: "",
  //     siteIcon:""
  //   }
  // },
];

module.exports = sites;