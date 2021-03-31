import React from 'react';
import propTypes from 'prop-types';
import { Link } from 'react-router-dom';
import { MovieCard } from '../movie-card/movie-card';

import {
  Container,
  Card,
  Button,
  ListGroup
} from 'react-bootstrap';

import './genre-view.scss';

export class GenreView extends React.Component {
  constructor() {
    super();

    this.state = {};
  }

  render() {
    const { genre, movies } = this.props;

    if (!genre) return null;

    return (
      <div className='genre-view'>
        <Container>
          <Card className='genre-card'>
            <Card.Body>
              <Card.Title className='genre-name'>{genre.Genre.Name}</Card.Title>
              <Card.Text className='genre-space'>~</Card.Text>
              <Card.Text className='genre-description'>{genre.Genre.Description}</Card.Text>
            </Card.Body>
          </Card>
          <Card className='genre-moreMovies'>
            <Card.Body>
              <Card.Title className='genre-movies'>{genre.Genre.Name} Movies:</Card.Title>
              <ListGroup>
                <div className='genre-view-movies'>
                  {movies.map((movie) => {
                    if (movie.Genre.Name === genre.Genre.Name) {
                      return (<MovieCard key={movie._id} movie={movie} />)
                    }
                  })}
                </div>
              </ListGroup>
            </Card.Body>
          </Card>

          <Card.Footer className='director-footer'>
            <Link to={`/`}>
              <Button className='returnButton' variant='dark'>Return to Movie List</Button>
            </Link>
          </Card.Footer>
        </Container>
      </div>
    )
  }
}

GenreView.propTypes = {
  movie: propTypes.shape({
    Genre: propTypes.shape({
      Name: propTypes.string.isRequired,
      Description: propTypes.string.isRequired,
    })
  })
};
