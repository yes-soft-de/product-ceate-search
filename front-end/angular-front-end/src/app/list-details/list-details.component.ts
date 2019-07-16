import { Component, OnInit } from '@angular/core';
import {ProductsService} from '../products.service';

@Component({
  selector: 'app-list-details',
  templateUrl: './list-details.component.html',
  styleUrls: ['./list-details.component.scss']
})
export class ListDetailsComponent implements OnInit {
  productList = [];
  constructor(private productsService: ProductsService) { }

  ngOnInit() {
    this.productsService.getProductList().subscribe( productItem => {
      this.productList = productItem;
    });
  }

}
