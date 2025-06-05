import React from 'react';
import PaginationItemLink from './PaginationItemLink.js';
import useDataContext from '../context/useDataContext.js';
import useSettingsContext from '../context/useSettingsContext.js';
import useCore from '../methods/core/useCore.js';

function PaginationLinks() {
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
          <PaginationItemLink 
            key={i} 
            pageNumber={output} 
          ></PaginationItemLink>
        );
      }
    }

    if(!firstPages && maxPages > list.length) {
      first = <PaginationItemLink 
        pageNumber={1}
        className={'first-item'}
      ></PaginationItemLink>
    }

    if (!lastPages && maxPages > list.length) {
      last = <PaginationItemLink 
        pageNumber={maxPages}
        className={'last-item'}
      ></PaginationItemLink>
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

export default PaginationLinks;