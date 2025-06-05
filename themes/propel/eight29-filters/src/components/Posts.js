import React from 'react';
import Post from './posts/Post';
import Card from './posts/Card';
import Staff from './posts/Staff';
import Pagination from './Pagination';
import PaginationLinks from './PaginationLinks';
import LoadMore from './LoadMore';
import useSettingsContext from '../context/useSettingsContext';
import useDataContext from '../context/useDataContext';
import useCore from '../methods/core/useCore';
import * as DOMPurify from 'dompurify';

function Posts() {
  const {paginationStyle, postType, postsPerRowParameter} = useSettingsContext();
  const {posts, postTypes, loading, globalData} = useDataContext();
  const {resetSelected} = useCore();
  let noResultsClasses = '';
  let noResultsElement;

  //Post Type Components - Add post types and component names to this object
  const components = {
    'post': Card,
    'post_b': Post,
    'post_c': Post,
    'post_d': Post,
    'staff': Staff   
  };

  if (globalData.noResults) {
    noResultsElement = <div dangerouslySetInnerHTML={{ __html: DOMPurify.sanitize(globalData.noResults) }} onClick={(e) => {
      if ('#clear' === e.target.getAttribute('href')) {
        e.preventDefault();
        resetSelected();
      }
    }}></div>
  } else {
    noResultsElement = <div>
      Sorry, no results.

      <div className="wp-block-button is-style-secondary">
        <button className="wp-block-button__link" onClick={() => {resetSelected()}}>Clear Filters</button>
      </div>
    </div>
  }

  //By default each post type uses the Post component
  if (postTypes && postType) {
    if (components[postType] === undefined) {
      components[postType] = Card;
    }
  }

  const ThePost = components[postType];
  let tempPostItems = [];
  let postItems = [];

  if (posts) {
    tempPostItems = posts.map((post, index) => {
      return (
        <ThePost 
          key={index}
          post={post}
        ></ThePost>
      )
    });

    postItems = tempPostItems;

    if ('news' === postType && tempPostItems.length) {
      postItems = [];
      let currentYear = '';
      let pastEvents = false;
      

      tempPostItems.forEach((postItem, index) => {
        if (postItem.props && postItem.props.post && postItem.props.post.eight29_custom.news_year) {
          if (postItem.props.post.eight29_custom.news_year !== currentYear) {
            postItems.push(<h2 key={`month-${index}`} className="block-archive-news-grid__year">{postItem.props.post.eight29_custom.news_year}</h2>);
            currentYear = postItem.props.post.eight29_custom.news_year;
          }
        }

        postItems.push(postItem);
      });
    }
  }

  const loadingClass = loading ? 'loading-active' : '';
  let postsContent;
  let paginationContent;

  if (paginationStyle === 'more') {
    paginationContent = <LoadMore></LoadMore>
  }

  else if (paginationStyle === 'pagination') {
    paginationContent = <Pagination></Pagination>
  }

  else if (paginationStyle === 'links') {
	paginationContent = <PaginationLinks></PaginationLinks>
  }

  if (posts && posts.length > 0) {
    postsContent = <div>
      <div className={`eight29-posts ${loadingClass}`} style={postsPerRowParameter}>
        {postItems}
      </div>

      {paginationContent}
    </div>
  }

  else {
    if (!loading) {
      if ('resource' === postType || 'post' === postType || 'event' === postType) {
        noResultsClasses = ' bg-black';
      }

      postsContent = <div className={`no-results${noResultsClasses}`}>
        {noResultsElement}
      </div>
    }
  }

  return (
   <section className="eight29-posts-container">
      {postsContent}
   </section>
  );
}

export default Posts;