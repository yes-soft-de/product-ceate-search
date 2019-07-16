import {Injectable} from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {catchError, map} from 'rxjs/operators';
import {ProductResponse} from './product-response';
import {ProductItem} from './product-item';
import {Observable, throwError} from 'rxjs';
import {ToastrService} from 'ngx-toastr';
import {Router} from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class ProductsService {
  configUrl = 'http://127.0.0.1:8000/painting/search/latest';
  serverUrl = 'http://127.0.0.1:8000/createPainting';
  httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json',
      responseType: 'text'
    })
  };
  responseArrived = false;
  constructor(private http: HttpClient, private toastr: ToastrService, private router: Router) {
  }

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

  postProduct(product: ProductItem) {
    this.responseArrived = false;
    return this.http.post<ProductItem>(this.serverUrl, JSON.stringify(product), this.httpOptions)
      .subscribe(
        data => {
          this.toastr.success('Painting is Added');
          console.log('POST Request is successful', data);
          this.responseArrived = true;
          this.router.navigate(['/']);
        }, error1 => {
          console.log('Error', error1);
          this.toastr.error('Error! ' + error1);
          this.responseArrived = true;
        }
      );
  }
}
