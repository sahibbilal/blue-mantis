import React from 'react';
import PropTypes from 'prop-types';
import useSettingsContext from '../../context/useSettingsContext';
import * as DOMPurify from 'dompurify';

function Card(props) {
  const {
    postType
  } = useSettingsContext();

  const {post} = props;
  let card;

  Card.propTypes = {
    post: PropTypes.object
  }

  if (post.card) {
	card = DOMPurify.sanitize(post.card, { ADD_ATTR: ['target'] });
  }

  return (
    <article id={`${postType}-${post.id}`} className="eight29-post" dangerouslySetInnerHTML={{ __html: card }}></article>
  );
}

export default Card; 