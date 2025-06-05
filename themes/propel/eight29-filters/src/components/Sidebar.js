import React, {useState, useEffect} from 'react';
import PropTypes from 'prop-types';
import FilterSearch from './filters/FilterSearch';
import FilterCheckbox from './filters/FilterCheckbox';
import FilterSelect from './filters/FilterSelect';
import FilterAccordionMultiSelect from './filters/FilterAccordionMultiSelect';
import FilterAccordionSingleSelect from './filters/FilterAccordionSingleSelect';
import FilterButtonGroup from './filters/FilterButtonGroup';
import FilterOrderBy from './filters/FilterOrderBy';
import FilterDate from './filters/FilterDate';
import useSettingsContext from '../context/useSettingsContext'; 
import useDataContext from '../context/useDataContext';
import useCore from '../methods/core/useCore';

function Sidebar(props) {
  const { 
    autoLoadFilters,
    sidebarLeft,
    sidebarRight
  } = props;

  const {
    selected,
    filters,
    currentPage,
    results 
  } = useDataContext();

  const {
    layout,
    mobileStyle, 
    displayPostCounts,
    displayReset,
    displayResults,
    displaySort,
    displaySearch,
    postsPerPage,
    postType
  } = useSettingsContext();

  const {resetSelected} = useCore();
  const [modalVisible, setModalVisible] = useState(false);
  const className = props.className ? props.className : '';
  
  const components = {
    'checkbox': FilterCheckbox,
    'select' : FilterSelect,
    'button-group' : FilterButtonGroup,
    'accordion-multi-select' : FilterAccordionMultiSelect,
    'accordion-single-select' : FilterAccordionSingleSelect,
    'date' : FilterDate
  }

  const filterList = autoLoadFilters ? [] : props.children;
  let modalClose;
  let modalOpen;
  let applyFilters; 
  let contentLeft;
  let contentRight;
  let sidebarDetail;
  let reset;
  let currentResults;
  let startResult;
  let totalResults;
  let searchComponent;
  let sortComponent;
  let filterLabel = "Filter";

  Sidebar.propTypes = {
    autoLoadFilters: PropTypes.bool,
    sidebarLeft: PropTypes.element,
    sidebarRight: PropTypes.element,
    className: PropTypes.string,
    children: PropTypes.elementType
  }

  function toggleModal(e) {
    e.preventDefault();
    setModalVisible(!modalVisible);
  }

  function modalActiveClass() {
    let modalClassString = '';

    if(modalVisible) {
      modalClassString = 'modal-active';
    }

    return modalClassString;
  }

  if (Object.entries(filters).length !== 0 && autoLoadFilters) {
    let i = 0;
    for (const taxonomy in filters) {
      const type = filters[taxonomy].type;
      const TheFilter = components[type];

      filterList.push(
        <TheFilter
          key={i++}
          label={filters[taxonomy].label}
          option={filters[taxonomy].option}
          taxonomy={filters[taxonomy].terms}
          taxSlug={taxonomy}
          selected={selected}
          displayPostCounts={displayPostCounts}
          collapsible={filters[taxonomy].collapsible}
          scrollable={filters[taxonomy].scrollable}
          dropdown={filters[taxonomy].dropdown}
        ></TheFilter>
      );
    }
  }

  if (mobileStyle === 'modal') {
    modalClose = <header className="eight29-sidebar__header">
      <h3 className="eight29-sidebar__title">Filters</h3>
      <button
      className="eight29-sidebar-toggle eight29-sidebar-close" 
      onClick={(e) => {toggleModal(e)}}
      >
      </button>
    </header>

    modalOpen = <div className="wp-block-button is-style-primary wp-block-button--icon-left eight29-sidebar__sidebar-toggle-button">
      <button 
      className={'eight29-sidebar-toggle eight29-sidebar-open wp-block-button__link'} 
      onClick={(e) => {toggleModal(e)}}
      >
        {filterLabel}
      </button>
    </div>

    applyFilters = <div className="wp-block-button is-style-primary eight29-sidebar__show-results-button">
      <button 
      className="eight29-sidebar-toggle apply-filters wp-block-button__link" 
      onClick={(e) => {toggleModal(e)}}
      >Show My Results</button>
    </div>
  }

  if(displayResults) {
	if ( postsPerPage * currentPage > results ) {
		startResult = postsPerPage * (currentPage - 1) + 1;
		currentResults = results;
		totalResults = <span className="eight29-sidebar__results">Showing {startResult + '—' + currentResults} of {results} Results</span>
	} else {
		currentResults = postsPerPage * currentPage;
		startResult = currentResults - postsPerPage + 1;
		totalResults = <span className="eight29-sidebar__results">Showing {startResult + '—' + currentResults} of {results} Results</span>
	}

  }

  if (displayReset) {
    reset = <a className="eight29-sidebar__reset" onClick={() => {resetSelected()}}>
        <span>Clear</span> <span>All</span> <span>Filters</span>
      </a>
  }

  if (displaySearch && layout === 'default') {
    searchComponent = <FilterSearch></FilterSearch>
  }

  if (displaySort && layout === 'default') {
    sortComponent = <FilterOrderBy></FilterOrderBy>
  }

  if (autoLoadFilters) {
    contentLeft = <div className="eight29-filter-list left-content">
      {filterList}
    </div>
  }
  else {
    contentLeft = <div className="eight29-filter-list left-content">
      {sidebarLeft}
    </div>
  }

  if (sidebarRight && layout !== 'default') {
    contentRight = <div className="eight29-filter-list right-content">
      {sidebarRight}
    </div>
  }

  if (layout === 'default' && (reset || totalResults)) {
    sidebarDetail = <ul className="eight29-sidebar-detail">
      <li className="hidden-mobile-tablet">{totalResults}</li>
      <li className="hidden-desktop">{reset}</li>
      <li className="hidden-desktop">{results} items</li>
    </ul>
  }

  const content = <div className="eight29-filter-group">
    {searchComponent}
    {sortComponent}
    {contentLeft}
    {contentRight}
    <div className="hidden-mobile-tablet">{reset}</div>
  </div>

  return (
    <form className={`eight29-sidebar ${modalActiveClass()} ${className}`}>
      <div className="eight29-sidebar-content">
        {modalClose}
        {content}
        {applyFilters}
      </div>

      {modalOpen}
      <div className="hidden-desktop">{totalResults}</div>
    </form>
  );
}

export default Sidebar;