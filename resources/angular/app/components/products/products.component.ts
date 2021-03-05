import {Component, OnInit} from '@angular/core';
import {SharedService} from '../../services/shared.service';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';
import {Options, LabelType} from 'ng5-slider';
import {ApiService} from "../../services/api.service";
import {error} from "util";

@Component({
    selector: 'app-products',
    templateUrl: './products.component.html',
    styleUrls: ['./products.component.scss']
})
export class ProductsComponent implements OnInit {
    isLoadding = false;
    products: any;
    allProducts: any;
    category: any;
    sorting: any;
    brands = [];
    prices = [];
    colors = [];
    processors = [];
    MinPrice = 0;
    MaxPrice = 0;
    productsCount = 0;
    priceVal: any;
    options: Options = {
        floor: 0,
        ceil: 500,
        translate: (value: number, label: LabelType): string => {
            switch (label) {
                case LabelType.Low:
                    return '<b>Min :</b> $' + value;
                case LabelType.High:
                    return '<b>Max :</b> $' + value;
                default:
                    return '$' + value;
            }
        }
    };
    tranlsalteGlobal = (window as any)
    item = {
        'brands': false,
        'colors': false,
        'prices': false,
        'processors': false
    }
    productsFilter = {
        cat: '',
        name: '',
        brand: [],
        price: [],
        color: [],
        processor: [],
        perPage: 20,
        page: 1
    };
    public priceFilter = [];

    constructor(private sharedService: SharedService,
                private apiService: ApiService,
                private router: Router,
                private activatedRoute: ActivatedRoute) {
        if (!this.products) {
            this.products = {}
        }
        if (!this.allProducts) {
            this.allProducts = {}
        }
    }

    getMinMax() {
        this.sharedService.getMinMaxProduct().subscribe((res: any) => {
            this.MinPrice = res.min;
            this.MaxPrice = res.max;
        }, error => {
        }, () => {
            this.options = {
                floor: 0,
                ceil: this.MaxPrice,
                translate: (value: number, label: LabelType): string => {
                    switch (label) {
                        case LabelType.Low:
                            return '<b>Min :</b> $' + value;
                        case LabelType.High:
                            return '<b>Max :</b> $' + value;
                        default:
                            return '$' + value;
                    }
                }
            };
            this.getRangeResult(this.MinPrice, this.MaxPrice);
        });
    }


    ngOnInit() {
        // console.log("this.productsFilter", this.productsFilter )
        // console.log("windowwindowwindow",window)
        // console.log("windowwindowwindowtranslationxxxx",(window as any).translationxxxx)


        this.getMinMax();

        if (this.activatedRoute.snapshot.paramMap.get('id')) {
            this.productsFilter.cat = this.activatedRoute.snapshot.paramMap.get('id');
        }
        console.log(this.productsFilter);

        const {name, brand, price, color, processor, ...other} = this.activatedRoute.snapshot.queryParams;

        if (name) {
            this.productsFilter.name = name;
        }
        if (brand) {
            this.productsFilter.brand.push(brand);
        }
        if (price) {
            // this.productsFilter.price = price;
            this.productsFilter.price.push(price);
            console.log('price ' + price);
        }
        if (color) {
            this.productsFilter.color.push(color);
        }
        if (processor) {
            this.productsFilter.processor.push(processor);
        }

        this.productsFilter = {...this.productsFilter, ...other};

        if (this.productsFilter.cat) {
            this.productsFilterMethod('', '');
        } else {
            this.productsFilter.cat = 'all';
            this.productsFilterMethod('', '');
        }
        // this.productsCount = Object.keys(this.products).length
        // console.log(Object.keys(this.products).length);
        // this.MinPrice =  Math.min(...this.prices);
        // this.MaxPrice =  Math.max(...this.prices);


    }

    addQueryParams(filterObject) {
        const filterObj = filterObject;

        const {cat, perPage, name, brand, price, color, processor, ...other} = filterObj;

        const queryParams = {
            ...other,
        };

        if (name) {
            queryParams.name = [name];
        }

        if (!this.activatedRoute.snapshot.paramMap.get('id')) {
            queryParams.cat = cat;
        }

        if (filterObj.brand && brand.length > 0) {
            queryParams.brand = [brand];
        }

        if (filterObj.price && price.length > 0) {
            // debugger
            console.log(filterObj);
            filterObj.price ? filterObj.price = [] : '';
            queryParams.price = [price];
            // console.log(this.priceFilter);

        }


        if (filterObj.processor && processor.length > 0) {
            queryParams.processor = [processor];
        }

        this.router.navigate([], {
            queryParams,
        });

        console.log(queryParams.price);
        this.getRangeResult(this.MinPrice, this.MaxPrice);
    }

    productsFilterMethod(item, type) {
        this.isLoadding = true;


        if (['brand', 'color', 'processor'].includes(type)) {

            this.productsFilter[type].includes(item) ? this.productsFilter[type] = this.productsFilter[type].filter((elem) => elem != item) : this.productsFilter[type].push(item);
            // console.log("this.productsFilter.brand",this.productsFilter.brand)
            console.log("item", item);

        } else if (type === 'ProductsParPage') {
            console.log("type " + type);
            this.productsFilter.perPage = item;
        } else if (type === "price") {
            this.priceFilter = [];
            console.log(this.priceFilter);
            this.productsFilter[type] = [];
            this.productsFilter.perPage = item;
            this.priceVal = (<HTMLInputElement>event.target).value;
            this.productsFilter[type].includes(this.priceVal) ? this.productsFilter[type] = this.productsFilter[type].filter((elem) => elem != this.priceVal) : this.productsFilter[type].push(this.priceVal);
            console.log('range', this.priceVal);
        }

        this.addQueryParams({...this.productsFilter});

        this.sharedService.productsFilter({...this.productsFilter}).subscribe((res: any) => {
            // console.log(res.products);
            if (res.filters.list.brand) this.brands = Object.values(res.filters.list.brand);
            if (res.filters.list.color) this.colors = Object.values(res.filters.list.color);
            if (res.filters.list.processor) this.processors = Object.values(res.filters.list.processor);
            if (res.filters.list.price) this.prices = Object.values(res.filters.list.price);
            this.products = res.products.data;
            this.allProducts = res.products;
            // this.MinPrice =  this.prices[0];
            // this.MaxPrice =  this.prices[this.prices.length - 1]
            // console.log( "this.allProducts" , this.allProducts )
            // console.log("this.productsFilter",this.productsFilter)
            this.category = res.category;
            this.isLoadding = false;
            console.log(this.prices);
        }, err => this.isLoadding = false);
    }

    convertTotalPaginationNumberToArray(totalPages) {
        if (this.products) {
            // return [...Array(totalPages).keys()];
            // console.log("totalpage",totalPages)
            return new Array(totalPages)
        }
    }


    getRangeResult(min, max) {
        this.sharedService.getData(min, max).subscribe(res => {
            console.log(res)
            this.products = res;
        }, error => {
            console.log(error)
        }, () => {
        })
    }

    // pagination(url, checkIfIsWithParams = true) {
    //     this.isLoadding = true;
    //     if (url != null) {
    //         this.sharedService.pagination(url, checkIfIsWithParams).subscribe((res: any) => {
    //             if (res.products.data) {
    //                 this.products = res.products;
    //             }
    //             this.isLoadding = false;
    //         }, err => this.isLoadding = false);
    //     }
    // }
    pagination(event, page) {
        event.preventDefault()
        // console.log( "this.productsFilter.page>>" , this.productsFilter.page )
        // console.log( "page>>" , page )

        if (this.productsFilter.page !== page && page >= 1 && page <= this.allProducts.last_page) {
            console.log("condition true")
            this.isLoadding = true;
            this.productsFilter.page = page
            this.productsFilterMethod('', '')
        }
        return undefined;
    }

    toggleAccordian(event, filter) {
        var element = event.target;
        element.classList.toggle("active");
        if (this.item[filter]) {
            this.item[filter] = false;
        } else {
            this.item[filter] = true;
        }
        var panel = element.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    }

    onProductNumberSelected(ProductNumber) {
        this.productsFilter.perPage = ProductNumber
        // console.log(this.productsFilter.perPage)
    }

    sortingItems(val: any) {
        // console.log('sortingItems',val)
        // console.log(' this.products', this.products)

        this.productsFilter['sortBy'] = 'price';
        if (val === "LowtoHigh") {

            this.productsFilter['orderBy'] = 'asc';

            this.products.sort(function (a, b) {
                return a.price - b.price;   // <== to compare string values
            })
        }
        if (val === "HighToLow") {
            this.productsFilter['orderBy'] = 'desc';
            this.products.sort(function (a, b) {
                return b.price - a.price;   // <== to compare string values
            })
        }

        // console.log(' this.productsFilter', this.productsFilter)
        // console.log(' this.products', this.products)


    }
}
