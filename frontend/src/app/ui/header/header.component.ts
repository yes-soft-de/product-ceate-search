import { Component, OnInit } from '@angular/core';
import { from } from 'rxjs';
import { ProductsService } from '../../Services/products.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {

  items: any;

  constructor(private product: ProductsService) { }

  ngOnInit() {

  }

  searchPainting(form) {
    const searchValue = {
      "query" : form.value.search 
    };

    this.product.postSearching(searchValue);

    // .subscribe(
    //   data {
    //     console.log('yes done' + data);
    //   }, error {
    //     console.log('error i am sorry');
    //   }
    // );
  }

}
