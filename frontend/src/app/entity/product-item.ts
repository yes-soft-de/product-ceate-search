export class ProductItem {
  private id: number;
  private name: string;
  private imageUrl: string;
  private description: string;
  private size: string;
  private medium: string;
  private category: string;
  private artist: string;

  constructor() {
  }

  getArtist(): string {
    return this.artist;
  }

  getName(): string {
    return this.name;
  }

  getImageUrl(): string {
    return this.imageUrl;
  }

  getDescription(): string {
    return this.description;
  }

  getSize(): string {
    return this.size;
  }

  getMedium(): string {
    return this.medium;
  }

  getCategory(): string {
    return this.category;
  }

  setName(name: string): void {
    this.name = name;
  }

  setImageUrl(url: string) {
    this.imageUrl = url;
  }

  setDescription(desc: string) {
    this.description = desc;
  }

  setSize(size: string) {
    this.size = size;
  }

  setMedium(medium: string) {
    this.medium = medium;
  }

  setCategory(category: string) {
    this.category = category;
  }

  setArtist(artist: string) {
    this.artist = artist;
  }

  toString() {
    return 'name: ' + this.getName() + ', Artist: ' + this.getArtist() + ', url: ' + this.getImageUrl()
      + ', desc: ' + this.getDescription() + ', Size: ' + this.getSize() + ', Medium: ' + this.getMedium()
      + ', Category: ' + this.getCategory();
  }
}
