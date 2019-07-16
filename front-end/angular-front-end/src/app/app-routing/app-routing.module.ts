import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {DashboardComponent} from '../dashboard/dashboard.component';
import {CommonModule} from '@angular/common';
import {ListComponent} from '../list/list.component';
import {PaintingDetailsComponent} from '../painting-details/painting-details.component';
import {AddPaintingComponent} from '../add-painting/add-painting.component';

const routes: Routes = [
  {
    path: '',
    component: DashboardComponent,
  },
  {
    path: 'painting/:id',
    component: PaintingDetailsComponent
  },
  {
    path: 'list',
    component: ListComponent,
  },
  {
    path: 'add',
    component: AddPaintingComponent,
  },
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
export class AppRoutingModule {
}
