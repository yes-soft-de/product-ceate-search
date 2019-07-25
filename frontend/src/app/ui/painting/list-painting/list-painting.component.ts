import { Component, OnInit } from '@angular/core';
import {ProductsService} from '../../../Services/products.service';

@Component({
  selector: 'app-list-painting',
  templateUrl: './list-painting.component.html',
  styleUrls: ['./list-painting.component.scss']
})
export class ListPaintingComponent implements OnInit {
  layout = 1;
  productList = [];
  activeProductList = [];
  dropdownList = ['all'];
  name: string;

  constructor(private productsService: ProductsService) { }

  ngOnInit() {
    this.getProductList();
    // this.createDropdown();
  }
  getProductList() {
    this.productsService.getProductList().subscribe(productItem => {
      this.productList = productItem;
      this.activeProductList = productItem;
      this.createDropdown();
    });
  }

  createDropdown() {
    // Construct Drop down Filter List
    for (const aProduct of this.productList) {
      this.dropdownList.push(aProduct.size);
    }
    // remove the repeatition
    this.dropdownList = [...new Set(this.dropdownList)];
  }

  filterList(size: string) {
    const products = [];
    if (size === 'all') {
      this.activeProductList = this.productList;  
    } else {
      for (const aProduct of this.productList) {
        if (aProduct.size === size) {
          products.push(aProduct);
        }
      }
      this.activeProductList = products;
    }
    console.log(this.activeProductList.length);
  }

  setLayout(layout: number) {
    this.layout = layout;
  }

  search() {
    if (this.name != '') {
      this.activeProductList = this.activeProductList.filter(res=> {
        return res.name.toLocaleLowerCase().match(this.name.toLocaleLowerCase());
      });
    } else if (this.name == '') {
      this.getProductList();
    }
  }
  
  sortItemsByPrice() {
    this.activeProductList.sort(((a, b) => (a.name > b.name) ? 1 : (a.name === b.name) ? ((a.name > b.name) ? 1 : -1) : -1 ));
    for (const x of this.activeProductList) {
      console.log(x.name);
    }
  }
}
