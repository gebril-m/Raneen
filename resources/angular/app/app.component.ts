import {Component} from '@angular/core';
import {Router} from '@angular/router';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent {
    search = {
        text: '',
        category: 'all'
    };
    isCartOpen = false;
    carts = [
        {
            name: 'product name',
            slug: '',
            picture: 'https://cf5.s3.souqcdn.com/item/2015/06/24/85/32/02/2/item_XL_8532022_8380988.jpg',
            product_number: 11,
            product_price: 200
        },
        {
            name: 'product name',
            slug: '',
            picture: 'https://cf5.s3.souqcdn.com/item/2015/06/24/85/32/02/2/item_XL_8532022_8380988.jpg',
            product_number: 11,
            product_price: 200
        },
        {
            name: 'product name',
            slug: '',
            picture: 'https://cf5.s3.souqcdn.com/item/2015/06/24/85/32/02/2/item_XL_8532022_8380988.jpg',
            product_number: 11,
            product_price: 200
        }
    ];
    cartTotal = 1000;
    categories = ['tvs', 'electronics', 'labtops'];

    constructor(private router: Router) {
    }

    productFilter() {
        console.log(this.search.text);
        this.router.navigate(['/search/', this.search.category], {queryParams: {text: this.search.text}});
    }

    removeProduct(product) {
        this.carts.splice(product, 1);
    }
}
