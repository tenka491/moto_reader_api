# moto_reader_api

This api will return news about motorcycles.

## Getting started

```
npm ci
npm start
```

You can either go to `http://localhost:8093` or your local IP + `:8093`

## Tech Stack
- Heroku
- Express
- Node JS


## Pre-Alpha TODO: List

- Look into RSS Feeds!

- Add Article selector
  - Add Article Img
- Add Site Icon
- Nice to haves
  - Add Article Date
  - Add default Sort order (by date)

---

## TODO:

- Add unit tests to check if each site returns something, this will help with checking if anything changed.
- Add Description
- Add Article Author
- Add Site Name
- Add per site counter
- Add more Sites
- Add TypeDefs
  - Request
  - Response

---

- Get Article by SiteIds

---

- Prep for deployment to Heroku
- add API to RapidAPI.com for a little money

### News sources

- https://www.asphaltandrubber.com/feed/
- https://www.cycleworld.com/arcio/rss/
- https://www.motorcyclistonline.com/arcio/rss/
- https://www.motorcycle.com/feed?20220427
- https://www.visordown.com/rss
- https://www.advpulse.com/feed/
- https://www.adventurebikerider.com/feed/
- https://www.motogp.com/en/news/rss

- https://ultimatemotorcycling.com/feed/
- https://www.webbikeworld.com/feed/
- https://www.rideapart.com/rss/articles/all/
- https://www.motorcyclecruiser.com/arcio/rss/
- https://ridermagazine.com/feed/

- https://www.cyclenews.com/
- https://www.motorcyclenews.com/

## RSS  - XML To JSON
https://www.npmjs.com/package/xml2js
