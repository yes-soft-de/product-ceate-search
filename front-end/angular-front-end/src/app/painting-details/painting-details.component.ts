import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {ProductsService} from '../products.service';

@Component({
  selector: 'app-painting-details',
  templateUrl: './painting-details.component.html',
  styleUrls: ['./painting-details.component.scss']
})
export class PaintingDetailsComponent implements OnInit {
  id = -1;
  constructor(private route: ActivatedRoute, private service: ProductsService) {
  }

  ngOnInit() {
    this.getPainting();
  }

  getPainting(): void {
    this.id = +this.route.snapshot.paramMap.get('id');
    this.service.getProductById(this.id);
  }

}
