import React from 'react';
import { Link } from 'react-router-dom';
import propTypes from 'prop-types';
import { MovieCard } from '../movie-card/movie-card';

import {
  Card,
  Button,
  Container,
  ListGroup,
} from 'react-bootstrap';

import './director-view.scss';

export class DirectorView extends React.Component {
  constructor() {
    super();

    this.state = {};
  }

  render() {
    const { director, movies } = this.props;

    if (!director) return null;

    return (
      <div className='director-view'>
        <Container>
          <Card className='director-card'>
            <Card.Body>
              <Card.Title className='director-name'>{director.Director.Name}</Card.Title>
              <Card.Text className='director-space'>~</Card.Text>
              <Card.Text className='director-bio'>{director.Director.Bio}</Card.Text>
            </Card.Body>
          </Card>
          <Card className='director-moreMovies'>
            <Card.Body>
              <Card.Title className='director-movies'>Movies by {director.Director.Name}:</Card.Title>
              <ListGroup>
                <div className='director-view-movies'>
                  {movies.map((movie) => {
                    if (movie.Director.Name === director.Director.Name) {
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

DirectorView.propTypes = {
  movie: propTypes.shape({
    Director: propTypes.shape({
      Name: propTypes.string.isRequired,
      Bio: propTypes.string.isRequired
    })
  })
};