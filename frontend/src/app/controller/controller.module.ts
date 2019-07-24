import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import { DashboardComponent } from '../ui/dashboard/dashboard.component';
import {CommonModule} from '@angular/common';
import {ListPaintingComponent} from '../ui/painting/list-painting/list-painting.component';
import {AddPaintingComponent} from '../ui/painting/add-painting/add-painting.component';
import {DetailsPaintingComponent} from '../ui/painting/details-painting/details-painting.component';

const routes: Routes = [
  {path: '', component: DashboardComponent},
  {path: 'list', component: ListPaintingComponent},
  {path: 'painting/:id', component: DetailsPaintingComponent},
  {path: 'add', component: AddPaintingComponent},
];

@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    RouterModule.forRoot(routes)
  ],
  exports: [
    RouterModule
  ],
})
export class ControllerModule { }
