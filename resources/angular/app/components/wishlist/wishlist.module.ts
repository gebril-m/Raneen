import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {WishlistComponent} from './wishlist.component';
import {RouterModule, Routes} from '@angular/router';
// import {ProductComponent} from './product/product.component';
import {SharedService} from '../../services/shared.service';
import {HttpClientModule} from '@angular/common/http';
import {FormsModule} from '@angular/forms';

const routes: Routes = [
  {
    path: '',
    component: WishlistComponent
  }
];

@NgModule({
  declarations: [WishlistComponent],
  imports: [
    RouterModule.forChild(routes),
    CommonModule,
    HttpClientModule,
    FormsModule
  ],
  providers: [SharedService]
})
export class WishlistModule { }
