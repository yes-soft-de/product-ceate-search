import {Component, OnInit} from '@angular/core';
import {ProductItemInterface} from '../product-item-interface';
import {ProductItem} from '../product-item';
import {ProductsService} from '../products.service';
import {ToastrService} from 'ngx-toastr';

@Component({
  selector: 'app-add-painting',
  templateUrl: './add-painting.component.html',
  styleUrls: ['./add-painting.component.scss']
})
export class AddPaintingComponent implements OnInit {
  product: ProductItemInterface;

  constructor(private service: ProductsService, private toastr: ToastrService) {
  }

  ngOnInit() {
  }

  submitPainting(form) {
    const productItem: ProductItem = new ProductItem();
    productItem.setName(form.value.paintingName);
    productItem.setArtist(form.value.artistName);
    productItem.setCategory(form.value.style);
    productItem.setSize(form.value.size);
    productItem.setImageUrl(form.value.imgUrl);
    productItem.setMedium(form.value.medium);
    productItem.setDescription(form.value.description);
    console.log(productItem.toString());
    // Send the Json to Backend
    this.service.postProduct(productItem);

    this.toastr.success('Hello world!', 'Toastr fun!');
  }

  setProductName(name: string) {
    this.product.name = name;
  }

  setProductImgUrl(imgUrl: string) {
    this.product.image_url = imgUrl;
  }

  setProductDescription(description: string) {
    this.product.description = description;
  }

  setProductSize(size: string) {
    this.product.size = size;
  }

  setProductMedium(medium: string) {
    this.product.medium = medium;
  }

  setProductCategory(category: string) {
    this.product.category = category;
  }
}
