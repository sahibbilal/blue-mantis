import React, {useState, useEffect} from 'react';
import PropTypes from 'prop-types';
import SimpleBar from 'simplebar-react';
import useDataContext from '../../context/useDataContext';
import useSettingsContext from '../../context/useSettingsContext';

function FilterContainer(props) {
  const {
    className,
    label,
    taxSlug,
    scrollable,
    collapsible,
    filterId
  } = props;

  let openState = false;

  // if (window.innerWidth < 992) {
  //   openState = true;
  // }

  const {selected, openFilter, setOpenFilter, filters} = useDataContext();
  const {postType} = useSettingsContext();
  const collapseClass = collapsible ? 'collapsible' : '';
  const [open, setOpen] = useState(openState);
  const [count, setCount] = useState(0);
  let content;
  let labelHeading;
  let labelContent;
  let filterLabel;

  FilterContainer.propTypes = {
    className: PropTypes.string,
    label: PropTypes.string,
    taxSlug: PropTypes.string,
    scrollable: PropTypes.bool,
    collapsible: PropTypes.bool,
    filterId: PropTypes.string.isRequired,
    children: PropTypes.oneOfType([
      PropTypes.arrayOf(PropTypes.node),
      PropTypes.node,
      PropTypes.element
    ])   
  }

  useEffect(() => {
    if (taxSlug !== openFilter && window.innerWidth >= 992) {
      setOpen(false);
    }
  }, [openFilter]);

  function countClass() {
    let classString = '';

    if (count > 0) {
      if (!postType || 'media_gallery_item' !== postType) {
        classString = 'count-visible';
      }
    }

    return classString;
  }

  function updateCount() {
    if (selected && taxSlug && selected[taxSlug] !== undefined) {
      setCount(selected[taxSlug].length);
    }
  }

  function toggleOpen() {
    if (collapsible) {
      setOpenFilter(taxSlug);
      setOpen(!open);
    }
  }

  function toggleClass() {
    let classString = '';

    if (open) {
      classString = 'open';
      document.addEventListener('click', clickOffMenu);
      document.addEventListener('keydown', clickOffMenu);
    } else {
      document.removeEventListener('click', clickOffMenu);
      document.removeEventListener('keydown', clickOffMenu);
    }

    return classString;
  }

  function clickOffMenu(e) {
    if (
      (e.key === 'Escape' ||
      (e.key === undefined &&
        e.target &&
        !e.target.closest('.collapsible')))
      && window.innerWidth >= 992
    ) {
      setOpen(false);
    }
  }

  if (scrollable) {
    content = <SimpleBar>{props.children}</SimpleBar>
  }
  else {
    content = props.children;
  }

  if (selected[taxSlug] && selected[taxSlug].length) {
    if(1 === selected[taxSlug].length) {
      const termNames = [];

      filters[taxSlug].terms.forEach(term => {
        if (selected[taxSlug].includes(term.id)) {
          termNames.push(term.name);
        }
      });
  
      filterLabel = termNames.join(', ');
    } else {
      filterLabel = 'Multiple';
    }
  } else {
    filterLabel = 'Select ' + label;
  }

  if (filterLabel !== "Select undefined") {
    labelHeading = <div
      className="eight29-filter-label__heading"
    >
      <span>{filterLabel}</span>
    </div>

    labelContent = <label
      onClick={() => toggleOpen()}
      className={`eight29-filter-label ${countClass()}`}
      data-count={count}
      htmlFor={`${filterId}-input`}
    >
      <span>{filterLabel}</span>
    </label>
  }

   useEffect(() => {
    updateCount();

    if (postType && ('media_gallery_item' === postType || 'post' === postType)) {
      setOpen(false);
    }
  }, [selected]);

  return(
    <div id={filterId} className={`eight29-filter ${className}`}>
      <div className={`accordion-select ${toggleClass()} ${collapseClass}`}>
        {labelHeading}

        {labelContent}

        <div>
          {content}
        </div>
      </div>
    </div>
  )
}

export default FilterContainer;