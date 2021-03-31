import React from 'react';
import axios from 'axios';
import { BrowserRouter as Router, Route, Switch, Link, Redirect } from "react-router-dom";
import { connect } from 'react-redux';
import PropTypes from 'prop-types';

import { setMovies, setUsers } from '../../actions/actions';

import MoviesList from '../movies-list/movies-list';
import { MovieCard } from '../movie-card/movie-card';
import { MovieView } from '../movie-view/movie-view';
import { LoginView } from '../login-view/login-view';
import { RegisterView } from '../registration-view/registration-view'
import { DirectorView } from '../director-view/director-view';
import { GenreView } from '../genre-view/genre-view';
import { ProfileView } from '../profile-view/profile-view';
import Config from '../../config';

import './main-view.scss'

import {
  Navbar, Nav, Container, Row, Col, Form, Jumbotron, NavDropdown, Button, Card
} from 'react-bootstrap';

export class MainView extends React.Component {
  constructor() {
    super();
    // Initial state is set to null
    this.state = {
      movies: [],
      selectedMovie: "",
      user: ""
    };
  }

  // username token
  getMovies(token) {
    axios.get(`${Config.API_URL}/movies`, {
      headers: { Authorization: `Bearer ${token}` }
    })
      .then(response => {
        this.props.setMovies(response.data);
      })
      .catch(function (error) {
        console.log(error);
      });
  }

  // verify user is logged in in local storage
  componentDidMount() {
    let accessToken = localStorage.getItem('token');
    if (accessToken !== null) {
      this.setState({
        user: localStorage.getItem('user')
      });
      this.getMovies(accessToken);
    }
  }

  /*When a movie is clicked, this function is invoked and updates the state of the `selectedMovie` *property to that movie*/
  onMovieClick(movie) {
    this.setState({
      selectedMovie: movie
    });
  }

  // register user
  onRegister(register) {
    this.setState({
      register
    });
  }

  /* When a user successfully logs in, this function updates the `user` property in state to that *particular user*/
  onLoggedIn(authData) {
    // console.log(authData);
    this.setState({
      user: authData.user.Username
    });

    localStorage.setItem('token', authData.token);
    localStorage.setItem('user', authData.user.Username);
    this.getMovies(authData.token);
  }

  // log out user
  onLogout() {
    this.setState(state => ({
      user: null
    }));

    localStorage.removeItem('user');
    localStorage.removeItem('token');
  }

  // selectedMovie state back to null, rendering the main-view page on the DOM
  onBackClick() {
    this.setState({
      selectedMovie: null
    });
  }

  render() {
    let { movies } = this.props;
    let { user, register } = this.state;


    // if (!user) return <LoginView onLoggedIn={user => this.onLoggedIn(user)} />;
    if (!movies) return <div className="main-view" />;


    return (
      <Router>
        <div className="main-view">
          {/* Navbar */}
          <header>
            <Navbar expand="lg" fixed="top" className='nav-bar'>
              <Navbar.Brand className='app-name navbar-brand' as={Link} to={`/`} target='_self'>myFlix</Navbar.Brand>
              <Navbar.Toggle aria-controls="basic-navbar-nav" />
              <Navbar.Collapse id="basic-navbar-nav">
                <Nav className="mr-auto">
                  {user &&
                    <Nav.Link as={Link} to={`/users/${user}`} target='_self' className='navbar-item'>My Account</Nav.Link>
                  }
                </Nav>
                <Form inline>
                  {user &&
                    <Link to={`/`}>
                      <Button variant="dark" className='logout-button' onClick={() => this.onLogout()}>Logout</Button>
                    </Link>
                  }
                </Form>
              </Navbar.Collapse>
            </Navbar>
          </header>
          {/* HomeView - working on the styling of this page, will be login page for now */}
          <Route exact path="/" render={() => {
            if (!user) return <LoginView onLoggedIn={user => this.onLoggedIn(user)} />;
            // return movies.map(m => <MovieCard key={m._id} movie={m} />)
            return (<MoviesList movies={movies} />);
          }
          } />
          <Route exact path="/login" render={() => {
            if (!user) return <LoginView onLoggedIn={user => this.onLoggedIn(user)} />;
            // return movies.map(m => <MovieCard key={m._id} movie={m} />)
            return (<MoviesList movies={movies} />);
          }
          } />

          <Route path="/register" render={() => {
            if (!register) return <RegisterView onRegister={(register) => this.onRegister(register)} />
          }} />
          {/* you keep the rest routes here */}
          <Route path="/movies/:movieId" render={({ match }) => <MovieView movie={movies.find(m => m._id === match.params.movieId)} />} />
          <Route path="/directors/:name" render={({ match }) => {
            if (!movies.length) return <div className='main-view' />;
            return <DirectorView director={movies.find((m) => m.Director.Name === match.params.name)} movies={movies} />
          }
          } />
          <Route path="/genres/:name" render={({ match }) => {
            if (!movies.length) return <div className='main-view' />;
            return <GenreView genre={movies.find((m) => m.Genre.Name === match.params.name)} movies={movies} />
          }
          } />
          <Route exact path='/users/:username' render={({ history }) => {
            if (!user) return <LoginView onLoggedIn={(data) => this.onLoggedIn(data)} />;
            if (movies.length === 0) return;
            return <ProfileView history={history} movies={movies} />
          }} />
        </div>
      </Router>
    );
  }
}

let mapStateToProps = (state) => {
  return { movies: state.movies, users: state.users }
}

export default connect(mapStateToProps, { setMovies, setUsers })(MainView);