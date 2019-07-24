import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailsPaintingComponent } from './details-painting.component';

describe('DetailsPaintingComponent', () => {
  let component: DetailsPaintingComponent;
  let fixture: ComponentFixture<DetailsPaintingComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DetailsPaintingComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DetailsPaintingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
