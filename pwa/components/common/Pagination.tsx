import Link from "next/link";
import { PagedCollection } from "../../types/collection";

interface Props {
  collection: PagedCollection<unknown>;
}

const Pagination = ({ collection }: Props) => {
  const view = collection && collection["hydra:view"];
  if (!view) return null;

  const {
    "hydra:first": first,
    "hydra:previous": previous,
    "hydra:next": next,
    "hydra:last": last,
  } = view;

  return (
    <nav aria-label="Page navigation">
      <ul className="inline-flex -space-x-px">
        <li>
          <Link href={first ? first.replace("_", "") : "#"}>
            <a
              className="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
              aria-label="First page"
            >
              <span aria-hidden="true">&lArr;</span> First
            </a>
          </Link>
        </li>

        <li>
          <Link href={previous ? previous.replace("_", "") : "#"}>
            <a
              className={"px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"}
              aria-label="Previous page"
            >
              <span aria-hidden="true">&larr;</span> Previous
            </a>
          </Link>
        </li>

        <li>
          <Link href={next ? next.replace("_", "") : "#"}>
            <a
              className="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
              aria-label="Next page"
            >
              Next <span aria-hidden="true">&rarr;</span>
            </a>
          </Link>
        </li>

        <li>
          <Link href={last ? last.replace("_", "") : "#"}>
            <a
              className="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
              aria-label="Last page"
            >
              Last <span aria-hidden="true">&rArr;</span>
            </a>
          </Link>
        </li>
      </ul>
    </nav>
  );
};

export default Pagination;
