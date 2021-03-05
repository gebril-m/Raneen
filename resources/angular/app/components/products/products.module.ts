import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {ProductsComponent} from './products.component';
import {RouterModule, Routes} from '@angular/router';
import {ProductComponent} from './product/product.component';
import {SharedService} from '../../services/shared.service';
import {HttpClientModule} from '@angular/common/http';
import {FormsModule} from '@angular/forms';
import {Ng5SliderModule} from 'ng5-slider';

const routes: Routes = [
    {
        path: '',
        component: ProductsComponent
    }
];

@NgModule({
    declarations: [ProductsComponent, ProductComponent],
    imports: [
        RouterModule.forChild(routes),
        CommonModule,
        HttpClientModule,
        Ng5SliderModule,
        FormsModule
    ],
    providers: [SharedService]
})
export class ProductsModule {
}
