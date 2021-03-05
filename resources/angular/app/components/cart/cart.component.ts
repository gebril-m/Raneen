import { Component, OnInit } from '@angular/core';
import {CartService} from '../../services/cart.service';

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.scss']
})
export class CartComponent implements OnInit {

  cartLists;
  quantity;
  colorr;
  attr;
  totalPrice:number ;
  options;

  constructor(private cartService: CartService) {
    this.options = (numb) => {
      return new Array(Number(numb))
    }
  }

  ngOnInit() {
    this.getAllCart()
  }


  getAllCart(){

      this.cartService.getAllCarts().subscribe((res: any)=>{
      
      console.log("res getAllCart>>",res)
      
      this.cartLists =  res["cartProducts"] ;
      
      this.totalPrice =  res["cartProducts"].length ? res["cartProducts"].map(product => product.price * product.quantity).reduce((a, b) => a + b) : 0;
      var counter = 0;
      
      for(var i=0 ; i < res["cartProducts"].length ; i++){
        counter += parseInt(this.cartLists[i].quantity) ;
      }

      document.querySelector(".layout-header2 .cart-product").textContent = ''+ counter;
      document.querySelector(".cart-link .cart-product").textContent = '( '+ counter+' )';
      if(document.querySelector(".layout-header2 .cart-totalPrice")) 
        document.querySelector(".layout-header2 .cart-totalPrice").textContent = this.totalPrice.toString();
      // console.log("this.totalPricethis.totalPricethis.totalPrice",this.totalPrice)
    
    })
  }

  removeFromCart(id: any){
    
    console.log("removeFromCart id>>>",id)

    this.cartService.deleteItemFromCart(id).subscribe((res: any)=>{
      console.log('removeFromCart',res);
      
        if(res["status"] === "success"){
          // let indexOfWish = this.cartLists.findIndex( item => item.id === id);
          // this.cartLists.splice( indexOfWish , 1)
          this.getAllCart()
        }
    })

  }

  removeAllFromCart(){
    this.cartLists.map((Product)=>{
      this.removeFromCart(Product.id)
    })
  }

  onQuantitySelected(quantity : any,attribute: any,id : any){
    console.log( 'quantity',quantity,id);
    this.cartService.addItemToCart(id,attribute,quantity).subscribe((res: any)=>{
      
      console.log("onQuantitySelected",res)      
      if(res["quantity"] == quantity){
        console.log("onQuantitySelected",res)      
        this.getAllCart()
        this.totalPrice =  this.cartLists.map(product => product.id == id ? product.price * quantity : product.price * product.quantity).reduce((a, b) => a + b);
        console.log('total price',this.totalPrice)
      }
  })
  }

}
