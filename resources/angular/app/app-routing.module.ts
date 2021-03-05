import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {AppComponent} from './app.component';
import {HomeComponent} from './components/home/home.component';
import {SingleProductViewComponent} from './components/products/single-product-view/single-product-view.component';
import {WishlistComponent} from './components/wishlist/wishlist.component';
import {CartComponent} from './components/cart/cart.component';


const routes: Routes = [
    {
        path: '',
        component: HomeComponent
    },
    {
        path: 'search',
        loadChildren: './components/products/products.module#ProductsModule'
    },
    {
        path: ':lang/search',
        loadChildren: './components/products/products.module#ProductsModule'
    },
    {
        path: ':id/c',
        loadChildren: './components/products/products.module#ProductsModule'
    },
    {
        path: ':lang/:id/c',
        loadChildren: './components/products/products.module#ProductsModule'
    },
    {
        path: ':id/p',
        component: SingleProductViewComponent
    },
    {
        path: ':lang/:id/p',
        component: SingleProductViewComponent
    },
    // {
    //     path: 'wishlist',
    //     loadChildren: './components/wishlist/wishlist.module#WishlistModule'
    // },
    {
        path: 'wishlist',
        component: WishlistComponent
    },
    {
        path: 'cart',
        component: CartComponent
    },
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule {
}
