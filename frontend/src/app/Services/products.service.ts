import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {catchError, map} from 'rxjs/operators';
import {ProductResponse} from '../entity/product-response';
import {ProductItem} from '../entity/product-item';
import {Observable, throwError} from 'rxjs';
import { map } from 'rxjs/operators';
import { HeaderComponent } from '../ui/header/header.component';

@Injectable({
  providedIn: 'root'
})
export class ProductsService {
  // searchValue: HeaderComponent;
  configUrl = 'assets/sample_data.json';
  serverUrl = '127.0.0.1:9200/';
  httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json'
    })
  };
  
  constructor(
    private http: HttpClient) {
  }

  productList = [];


  // pipe: convert to something we deffined
  // map: take interface and convert data by it
  // map: use to deserialize
  getProductList() {
    return this.http.get<ProductResponse>(`${this.configUrl}`).pipe(
      map((response: ProductResponse) => {
        return response.data;
      })
    );
  }


  getProductById(id: number) {
    return this.http.get<ProductResponse>(`${this.configUrl}/${id}`).pipe(
      map((response: ProductResponse) => {
        return response.data;
      })
    );
  }

  // subscribe: is one from the observeable, send data and wait until the response come back
  // subscribe(data, error);
  postProduct(product: ProductItem) {
    return this.http.post(this.serverUrl, product, this.httpOptions).subscribe(
      data => {
        console.log('POST Request is successful ', data);
      }, error1 => {
        console.log('Error', error1);
      }
    );
  }

  // function to send search data from header to http Request
  postSearching(product) {
    // console.log(JSON.stringify(product));
    return this.http.post(this.serverUrl, JSON.stringify(product), this.httpOptions)
    .subscribe(result => {
      console.log(result);
    }, error => {
      console.log('sooory there is an error');
    });
  }
  // postSearching(product) {
  //   return this.http.post(this.serverUrl, JSON.stringify(product), this.httpOptions)
  //   .pipe(map(data => {})).subscribe(result => {
  //     console.log(result);
  //   }, error => {
  //     console.log('sooory there is an error');
  //   });
  // }
}