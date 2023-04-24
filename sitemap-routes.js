import React from 'react';
import { Route } from 'react-router';
 
export default (
  <Route>
	<Route path={window.appUrl} />
	<Route path={window.appUrl + 'product/:slug'} />
	<Route path={window.appUrl + 'detail/:slug'} />
	<Route path={window.appUrl + 'category/:slug'} />
  </Route>
);