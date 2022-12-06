import { Item } from "./item";

export class ValFoncier implements Item {
  public "@id"?: string;

  constructor(
    _id?: string,
    public dateAquisition?: Date,
    public type?: string,
    public codePostal?: string,
    public surface?: number,
    public prix?: number
  ) {
    this["@id"] = _id;
  }
}
