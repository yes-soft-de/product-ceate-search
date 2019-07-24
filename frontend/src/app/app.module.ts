import {BrowserModule} from '@angular/platform-browser';
import {NgModule, NO_ERRORS_SCHEMA} from '@angular/core';

import {HttpClientModule} from '@angular/common/http';
import {MDBBootstrapModule} from 'angular-bootstrap-md';
import {FormsModule} from '@angular/forms';

import {AppComponent} from './app.component';
import { ControllerModule } from './controller/controller.module';
import { UIComponent } from './ui/ui.component';
import { HeaderComponent } from './ui/header/header.component';
import { DashboardComponent } from './ui/dashboard/dashboard.component';
import { PaintingComponent } from './ui/painting/painting.component';
import { AddPaintingComponent } from './ui/painting/add-painting/add-painting.component';
import { DetailsPaintingComponent } from './ui/painting/details-painting/details-painting.component';
import { ListPaintingComponent } from './ui/painting/list-painting/list-painting.component';



@NgModule({
  declarations: [
    AppComponent,
    UIComponent,
    HeaderComponent,
    DashboardComponent,
    PaintingComponent,
    AddPaintingComponent,
    DetailsPaintingComponent,
    ListPaintingComponent
  ],
  imports: [
    BrowserModule,
    MDBBootstrapModule.forRoot(),
    HttpClientModule,
    FormsModule,
    ControllerModule,
  ],
  providers: [],
  bootstrap: [AppComponent],
  schemas: [NO_ERRORS_SCHEMA]
})
export class AppModule {
}
