import Sitemap from 'react-router-sitemap';
// require('babel-register');
 
const router = require('./router').default;
// const Sitemap = require('../').default;
 
(
    new Sitemap(router)
        .build("http://localhost/ndiio_react")
          .save("./public/sitemap.xml")
);