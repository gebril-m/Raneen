import { Component, OnInit } from '@angular/core';
import {SharedService} from '../../services/shared.service';
import {CartService} from '../../services/cart.service';

@Component({
    selector: 'app-wishlist',
    templateUrl: './wishlist.component.html',
    styleUrls: ['./wishlist.component.scss']
})
export class WishlistComponent implements OnInit {

    wishs;
    totalPrice;

    constructor(private sharedService: SharedService,private cartService: CartService) { }

    ngOnInit() {
        this.getAllWishList()
    }

    getAllWishList(){
        this.sharedService.getAllWishList().subscribe((res: any)=>{
            console.log("res getAllWishList>>",res)
            this.wishs = res['wishlistProducts']
            this.totalPrice = res['totalPrice']
            this.updateCounterHeaderIconWishList()
        })
    }

    updateCounterHeaderIconWishList(){
        this.sharedService.getAllWishList().subscribe((res: any)=>{
            console.log("res getAllWishList>>",res)
            // this.allWishList = res
            document.querySelector(".layout-header2 .wishlist-product").textContent = res.wishlistProducts.length
        })
    }

    updateCounterHeaderIconCart(){
        this.cartService.getAllCarts().subscribe((res: any)=>{
            console.log("res getAllCart>>",res)
            document.querySelector(".layout-header2 .cart-product").textContent = res.cartProducts.length;
        })
      }

    addToCart( id ){
        this.cartService.addItemToCart(id, '' , 1).subscribe((res: any)=>{
            console.log("res addItemToCart>>",res)

            this.updateCounterHeaderIconCart()
        })
    }

    addAllToCart(){
        this.wishs.forEach(element => {
            console.log(element.id);
            this.addToCart(element.id)
        });
    }

    removeFromWishList(id){

        console.log("addToWishList id>>>",id)

        this.sharedService.removeFromWishList(id).subscribe((res: any)=>{
            if(res["status"] === "success"){
                this.getAllWishList()
                // this.wishs = this.wishs.filter(item => item.id !== id);
            }
        })


    }

}
