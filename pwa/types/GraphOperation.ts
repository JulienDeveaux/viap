export class GraphOperation
{
  public "@id"?: string;

  constructor(
    _id?: string,
    public res?: string,
    public prixM2?: number[],

    public values?: string[]
  ) {
    this["@id"] = _id;
  }
}
