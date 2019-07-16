import { Component, OnInit } from '@angular/core';
import {ProductsService} from '../products.service';

@Component({
  selector: 'app-list',
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss']
})
export class ListComponent implements OnInit {
  layout = 1;
  productList = [];
  activeProductList = [];
  dropdownList = [];
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
    this.dropdownList = [...new Set(this.dropdownList)];
  }

  filterList(size: string) {
    const products = [];
    for (const aProduct of this.productList) {
      if (aProduct.size === size) {
        products.push(aProduct);
      }
    }
    this.activeProductList = products;
  }
  setLayout(layout: number) {
    this.layout = layout;
  }
  sortItemsByPrice() {
    this.activeProductList.sort(((a, b) => (a.name > b.name) ? 1 : (a.name === b.name) ? ((a.name > b.name) ? 1 : -1) : -1 ));
    for (const x of this.activeProductList) {
      console.log(x.name);
    }
  }
}
