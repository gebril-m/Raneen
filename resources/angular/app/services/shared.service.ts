import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {ApiService} from './api.service';

@Injectable({
    providedIn: 'root'
})
export class SharedService {
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

    getAllWishList() {
        return this.http.get(this.apiUrl.wishApiUrls().wishList + 'get');
    }

    addToWishList(id) {
        return this.http.get(this.apiUrl.wishApiUrls().wishList + `store?id=${id}`);
    }

    removeFromWishList(id) {
        return this.http.get(this.apiUrl.wishApiUrls().wishList + `delete?id=${id}`);
    }


    getAllProducts() {
        return this.http.post(this.apiUrl.postApiUrls().productsFilter, '', this.httpOptions);
    }

    getMinMaxProduct() {
        return this.http.get(this.apiUrl.getMinMaxApiUrl().getminmax);
    }

    productsFilter(body) {
        return this.http.post(this.apiUrl.postApiUrls().productsFilter, body, this.httpOptions);
    }

    getData(min: number, max: number) {
        return this.http.get(`/api/v1/products/filter/${min}/${max}`);
        // return this.http.get(this.apiUrl.getMinMaxApiUrl().getminmaxTwp);
    }

    // pagination(url, checkIfIsWithParams) {
    //     if (checkIfIsWithParams) {
    //         return this.http.post(url, '', this.httpOptions);
    //     } else {
    //         this.httpOptions.params = this.httpOptions.params.append('page', url);
    //         return this.http.post(this.apiUrl.postApiUrls().productsFilter, '', this.httpOptions);
    //     }
    // }
}
