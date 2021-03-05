import {Component, Input, OnInit} from '@angular/core';
import {SharedService} from '../../../services/shared.service';
import {CartService} from '../../../services/cart.service';


@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.scss']
})
export class ProductComponent implements OnInit {
    @Input() products;
    closeModel: boolean;
    productModel;
    allWishList;
    quantity = 1;
    colorActive = 'red';
    attr = 's';
    window = (window as any)
    constructor(private sharedService: SharedService,private cartService: CartService) {
        if(! this.products){
            this.products=[]
          }
        if(! this.productModel){
            this.productModel={}
          }
    }

    ngOnInit() {
        // this.getAllWishList();
    }

    getAllWishList(){
        this.sharedService.getAllWishList().subscribe((res: any)=>{
            console.log("res getAllWishList>>",res)
            // this.allWishList = res
            document.querySelector(".layout-header2 .wishlist-product").textContent = res.wishlistProducts.length
        })
    }

    addToWishList(id){
        // let checkIAvailable = this.allWishList.some( item => item === id ) 
        // if( checkIAvailable ){
        //     return;
        // }
        this.sharedService.addToWishList(id).subscribe((res: any)=>{
            console.log("res addToWishList>>",res)
            // this.getAllWishList()
            this.getAllWishList();
        })
        console.log("addToWishList id>>>",id)
    }
    
    getAllCart(){
        this.cartService.getAllCarts().subscribe((res: any)=>{
            console.log("res getAllCart>>",res)
            this.allWishList = res;
            var counter = 0;
            for(var i=0 ; i < res.cartProducts.length ; i++){
                counter += parseInt(res.cartProducts[i].quantity) ;
            }

            document.querySelector(".layout-header2 .cart-product").textContent = ''+ counter;

            // document.querySelector(".layout-header2 .cart-product").textContent = res.cartProducts.length
            document.querySelector(".layout-header2 .cart-totalPrice").textContent = res.totalPrice

        })
    }

    addToCart( id ){
        // let checkIAvailable = this.allWishList.some( item => item === id ) 
        // if( checkIAvailable ){
        //     return;
        // }
        console.log("e.target00000",id,[this.colorActive,this.attr].join() , this.quantity);
        
        
        this.cartService.addItemToCart(id, [this.colorActive,this.attr].join() , this.quantity).subscribe((res: any)=>{
            console.log("res addItemToCart>>",res)
            // updateCartNumber()
            this.getAllCart()
        })
        // console.log("addItemToCart id>>>", id )
    }

    openModel(product) {
        this.quantity = 1;
        this.colorActive='red';
        this.attr = 's'
        this.productModel = product;
        this.closeModel = true;
        console.log(this.productModel);
    }

    countMinus(){
        var currentVal = this.quantity
        if (!isNaN(currentVal) && currentVal > 1) {
            this.quantity = this.quantity - 1;
        }
    }

    countPlus(){
        var currentVal = this.quantity
        if (!isNaN(currentVal)) {
            this.quantity = this.quantity + 1;
        }
    }

    addClassActiveColor(color){
        this.colorActive = color
        console.log(this.colorActive);
    }
    addClassActiveAttr(attr){
        this.attr = attr
        console.log(this.attr);
    }

}
