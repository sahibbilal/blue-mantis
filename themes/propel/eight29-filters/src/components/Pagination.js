import React from 'react';
import PaginationItem from './PaginationItem.js';
import useDataContext from '../context/useDataContext.js';
import useSettingsContext from '../context/useSettingsContext.js';
import useCore from '../methods/core/useCore.js';

function Pagination() {
  const {
    pageNext, 
    pagePrev, 
    scrollUp
  } = useCore();

  const { 
    postType
  } = useSettingsContext();

  const { 
    currentPage,
    maxPages,
    setAfterFirstEvent
  } = useDataContext();

  const maxPageItems = 3;
  let paginationOutput = '';
  let paginationClasses = '';

  function clickNext() {
    scrollUp();
    pageNext();
    setAfterFirstEvent(true);
  }

  function clickPrev() {
    scrollUp();
    pagePrev();
    setAfterFirstEvent(true);
  }

  const pageItems = function(amount) {
    amount = amount > maxPages ? maxPages : amount;

    const middle = Math.round(amount/2);
    const list = [];
    const firstPages = currentPage > 0 && currentPage < amount;
    const lastPages = currentPage <= maxPages && currentPage > maxPages - (amount - 1);
    let output;
    let first = '';
    let last = '';

    for(let i = 0; i < amount; i++) {
      //Beginning
      if (firstPages) {
        output = 1 + i;
      }

      //End
      else if (lastPages) {
        output = (maxPages - amount) + (1 + i);
      }

      //Middle
      else { 
        output = currentPage - (middle - (i + 1));
      }

      if (output > 0 && output <= maxPages) {
        list.push(
          <PaginationItem 
            key={i} 
            pageNumber={output} 
          ></PaginationItem>
        );
      }
    }

    if(!firstPages && maxPages > list.length) {
      first = <PaginationItem 
        pageNumber={1}
        className={'first-item'}
      ></PaginationItem>
    }

    if (!lastPages && maxPages > list.length) {
      last = <PaginationItem 
        pageNumber={maxPages}
        className={'last-item'}
      ></PaginationItem>
    }

    return (
      <li className="pagination__list">
        <ul>
          {first}
          {list}
          {last}
        </ul>
      </li>
    );
  };

  if ('resource' === postType || 'post' === postType || 'event' === postType) {
    paginationClasses = ' bg-black';
  }

  if (maxPages > 1) {
    paginationOutput = <ul className={`pagination${paginationClasses}`}>
      {pageItems(maxPageItems)}
    </ul>
  }

  return paginationOutput;
}

export default Pagination;