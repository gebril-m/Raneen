import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  constructor() { }

  postApiUrls() {
    return {
      // productsFilter: 'http://ec2-3-15-182-195.us-east-2.compute.amazonaws.com:3030/api/v1/products/filter',
      productsFilter: '/api/v1/products/filter',
    };
  }

  wishApiUrls() {
    return {
      // productsFilter: 'http://ec2-3-15-182-195.us-east-2.compute.amazonaws.com:3030/api/v1/products/filter',
      wishList: '/wishlist/',
    };
  }

  cartApiUrls() {
    return {
      getCartItems: '/cart/get',
      AddItemToCart: '/cart/store',
      deleteCartItem: '/cart/delete',
    };
  }

  getMinMaxApiUrl() {
    return {
      // productsFilter: 'http://ec2-3-15-182-195.us-east-2.compute.amazonaws.com:3030/api/v1/products/filter',
      getminmax: '/api/v1/products/MinMax',
      getminmaxTwp: '/api/v1/filter/1/50',
    };
  }

}
