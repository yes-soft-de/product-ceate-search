import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {catchError, map} from 'rxjs/operators';
import {ProductResponse} from '../entity/product-response';
import {ProductItem} from '../entity/product-item';
import {Observable, throwError} from 'rxjs';
import {ToastrService} from 'ngx-toastr';
import {Router} from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class ProductsService {
  configUrl = 'assets/sample_data.json';
  serverUrl = 'http://127.0.0.1:8000';
  httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json'
    })
  };
  responseArrived = false;
  
  constructor(
    private http: HttpClient, 
    private toastr: ToastrService, 
    private router: Router) {
  }

  // pipe: convert to something we deffined
  // map: take interface and convert data by it | use to deserialize
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
    this.responseArrived = false;
    return this.http.post<ProductItem>(this.serverUrl + '/painting/create', JSON.stringify(product), this.httpOptions)
    .subscribe(
      data => {
        this.toastr.success('Painting is Added Successfully');
        console.log('POST Request is successful ', data);
        this.responseArrived = true;
        this.router.navigate(['/']);
      }, error1 => {
        console.log('Error', error1);
        this.toastr.error('Error! ' + error1);
        this.responseArrived = true;
      }
    );
  }

  
  // function to send search data from header to http Request
  postSearching(product) {
    return this.http.post<JSON>(this.serverUrl + '/painting/search', JSON.stringify(product), this.httpOptions)
    .subscribe(result => {
      console.log('POSt Done : ', result);
    }, error => {
      console.log('Sory there is an error', error);
    });
  }
  // postSearching(product) {
  //   return this.http.post(this.serverUrl + '/painting/search', JSON.stringify(product), this.httpOptions)
  //   .pipe(map(data => {})).subscribe(result => {
  //     console.log('POSt Done : ', result);
  //   }, error => {
  //     console.log('sooory there is an error', error);
  //   });
  // }
}