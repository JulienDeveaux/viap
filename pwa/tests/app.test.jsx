import { render, screen } from '@testing-library/react'
import '@testing-library/jest-dom'
import Graphs from '../pages/graphs/index'

describe('Graphs', () =>
{
    it('test test', () =>
    {
        render(<Graphs/>);

        const defaultTitle = screen.getByText('Prix moyen du m2');

        expect(defaultTitle).toBeInTheDocument();
    });
});
