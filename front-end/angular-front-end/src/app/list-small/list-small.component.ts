import { Component, OnInit } from '@angular/core';
import {ProductsService} from '../products.service';

@Component({
  selector: 'app-list-small',
  templateUrl: './list-small.component.html',
  styleUrls: ['./list-small.component.scss']
})
export class ListSmallComponent implements OnInit {
  productList = [];
  constructor(private productsService: ProductsService) { }

  ngOnInit() {
    this.productsService.getProductList().subscribe( productItem => {
      this.productList = productItem;
    });
  }
}
