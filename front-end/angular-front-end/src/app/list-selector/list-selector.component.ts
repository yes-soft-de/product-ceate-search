import {ComponentRef, ComponentFactoryResolver, ViewContainerRef, ViewChild, Component, OnInit} from '@angular/core';
import {ListSmallComponent} from '../list-small/list-small.component';
import {ListDetailsComponent} from '../list-details/list-details.component';

@Component({
  selector: 'app-list-selector',
  templateUrl: './list-selector.component.html',
  styleUrls: ['./list-selector.component.scss']
})
export class ListSelectorComponent implements OnInit {
  layout = 1;
  constructor() {
  }

  ngOnInit() {
  }
}
