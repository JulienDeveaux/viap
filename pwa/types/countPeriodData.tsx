export class CountPeriodData
{
  public "@id"?: string

  constructor(
    _id?: string,
    public periods?: any
  ) {
    this["@id"] = _id
  }
}
