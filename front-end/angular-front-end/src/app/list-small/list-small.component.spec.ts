import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ListSmallComponent } from './list-small.component';

describe('ListSmallComponent', () => {
  let component: ListSmallComponent;
  let fixture: ComponentFixture<ListSmallComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ListSmallComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ListSmallComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
