import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {ProductsService} from '../../../Services/products.service';

@Component({
  selector: 'app-details-painting',
  templateUrl: './details-painting.component.html',
  styleUrls: ['./details-painting.component.scss']
})
export class DetailsPaintingComponent implements OnInit {

  id = -1;
  constructor(private route: ActivatedRoute, private service: ProductsService) {}

  ngOnInit() {
    this.getPainting();
  }

  // 
  getPainting(): void {
    // get the id using route form link  
    this.id = +this.route.snapshot.paramMap.get('id');
    this.service.getProductById(this.id);
  }
}
