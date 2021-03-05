import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {SharedService} from './services/shared.service';
import {CartService} from './services/cart.service';
import {HttpClientModule} from '@angular/common/http';
import {FormsModule} from '@angular/forms';
import {HomeComponent} from './components/home/home.component';
import {SingleProductViewComponent} from './components/products/single-product-view/single-product-view.component';
import {WishlistComponent} from './components/wishlist/wishlist.component';
import {CartComponent} from './components/cart/cart.component';


@NgModule({
    declarations: [
        AppComponent,
        HomeComponent,
        SingleProductViewComponent,
        WishlistComponent,
        CartComponent,
    ],
    imports: [
        BrowserModule,
        AppRoutingModule,
        HttpClientModule,
        FormsModule
    ],
    providers: [SharedService, CartService],
    bootstrap: [AppComponent]
})
export class AppModule {
}
