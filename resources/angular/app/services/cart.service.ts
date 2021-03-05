import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {ApiService} from './api.service';

@Injectable({
  providedIn: 'root'
})
export class CartService {
  httpOptions = {
    headers: new HttpHeaders({
      'Access-Control-Allow-Origin': '*',
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': 'USTcYK9YnlC2PoHybf7u7xHSXYh8gWzoQpu85wuR'
    }),
    params: new HttpParams()
  };

  constructor(private http: HttpClient,
              private apiUrl: ApiService) {
  }

  getAllCarts() {
    return this.http.get(this.apiUrl.cartApiUrls().getCartItems);
  }

  addItemToCart(id, attribute, quantity) {
    // this.httpOptions.params = this.httpOptions.params.set('id', id);
    // return this.http.get(this.apiUrl.cartApiUrls().AddItemToCart, this.httpOptions);
    let params = new HttpParams();
        params = params.append('id', id);
        params = params.append('attribute', attribute);
        params = params.append('quantity', quantity);
    return this.http.get(this.apiUrl.cartApiUrls().AddItemToCart,{params: params});
  }

  // changeQuantityInCart(id , quantity) {
  //   // this.httpOptions.params = this.httpOptions.params.set('id', id);
  //   // return this.http.get(this.apiUrl.cartApiUrls().AddItemToCart, this.httpOptions);
  //   let params = new HttpParams();
  //       params = params.append('id', id);
  //       params = params.append('quantity', quantity);
  //   return this.http.get(this.apiUrl.cartApiUrls().AddItemToCart,{params: params});
  // }

  deleteItemFromCart(id) {
    this.httpOptions.params = this.httpOptions.params.set('id', id);
    return this.http.get(this.apiUrl.cartApiUrls().deleteCartItem, this.httpOptions);
  }
}
