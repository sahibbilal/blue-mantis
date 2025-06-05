import React from 'react';
import PropTypes from 'prop-types';
import useDataContext from '../context/useDataContext';
import useSettingsContext from '../context/useSettingsContext.js';
import useCore from '../methods/core/useCore';

function PaginationItemLink(props) {
  const {
    currentPage, 
    setCurrentPage,
    setAfterFirstEvent
  } = useDataContext();

  const { 
    postType
  } = useSettingsContext();

  let postTypeLink = '/blog';

  if ('resource' === postType) {
    postTypeLink = '/resources';
  }

  if ('news' === postType) {
    postTypeLink = '/news';
  }

  const {pageNumber} = props;
  const {scrollUp} = useCore();
  const currentClass = currentPage === pageNumber ? 'current-page' : '';
  const className = props.className !== undefined ? props.className : '';

  PaginationItemLink.propTypes = {
    pageNumber: PropTypes.number,
    className: PropTypes.string
  }

  function updatePaginationURL() {
	let canonicalLink = document.querySelector("link[rel='canonical']");
	let prevLink = document.querySelector("link[rel='prev']");
	let nextLink = document.querySelector("link[rel='next']");


	if (pageNumber !== 1) {
		window.history.pushState({}, '', postTypeLink + '/page/' + pageNumber + '/');

		canonicalLink.href = window.location.origin + postTypeLink + '/page/' + pageNumber + '/';
		if (prevLink) {
			prevLink.href = window.location.origin + postTypeLink + '/page/' + (pageNumber - 1) + '/';
		} else {
			let newPrevLink = document.createElement('link');
			newPrevLink.rel = 'prev';
			newPrevLink.href = postTypeLink + '/page/' + (pageNumber - 1) + '/';
			document.head.appendChild(newPrevLink);
		}
		if (nextLink) {
			nextLink.href = window.location.origin + postTypeLink + '/page/' + (pageNumber + 1) + '/';
		} else {
			let newNextLink = document.createElement('link');
			newNextLink.rel = 'next';
			newNextLink.href = postTypeLink + '/page/' + (pageNumber + 1) + '/';
			document.head.appendChild(newNextLink);
		}
	} else {
		window.history.pushState({}, '', postTypeLink);

		canonicalLink.href = window.location.origin + postTypeLink + '/';
	}
  }
  
  function clickHandler(pageNumber) {
    setCurrentPage(pageNumber);
    scrollUp();
    setAfterFirstEvent(true);
	updatePaginationURL();
  }

  return (
    <li className={className}>
      <a
	  	href={pageNumber !== 1 ? postTypeLink + '/page/' + pageNumber + '/' : postTypeLink + '/'} 
        className={`pagination__item ${currentClass}`}
        onClick={(e) => {
			e.preventDefault();
			clickHandler(pageNumber)
		}}
      >{pageNumber}</a>
    </li>
  );
}

export default PaginationItemLink;