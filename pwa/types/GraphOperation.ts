export class GraphOperation
{
  public "@id"?: string;

  constructor(
    _id?: string,
    public res?: string,
    public prixM2?: number[]
  ) {
    this["@id"] = _id;
  }
}
