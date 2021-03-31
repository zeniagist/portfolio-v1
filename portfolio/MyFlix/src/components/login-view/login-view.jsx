import React, { useState } from 'react';
import PropTypes from 'prop-types';

import { Link } from "react-router-dom";

// Redux
import { connect } from 'react-redux';

import './login-view.scss';
import Config from '../../config';

// react-bootstrap
import { Form, Button, Container, Col } from 'react-bootstrap';
import axios from 'axios';

export function LoginView(props) {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    /* Send a request to the server for authentication */
    axios.post(`${Config.API_URL}/login`, {
      Username: username,
      Password: password
    })
      .then(response => {
        const data = response.data;
        props.onLoggedIn(data);
      })
      .catch(e => {
        console.log('no such user')
      });
  };

  return (
    <React.Fragment>
      <Container>
        <Col
          md={{ span: 6, offset: 3 }}
          lg={{ span: 4, offset: 4 }}
          className='bg-white rounded p-3'
        >
          {/* Header */}
          <h1 className='text-dark text-center h3 mb-4'>
            Welcome to{' '}
            <span className='font-italic app-name'>
              myFlix
            </span>
          </h1>
          <h2 className='text-left h6 text-dark font-weight-bold mb-2'>
            Login to Your Account
          </h2>
          {/* Login Credentials */}
          <Form className='mb-2'>
            {/* Username */}
            <Form.Group className='mb-2' controlId='loginUsername'>
              <Form.Control
                autoFocus
                type='text'
                placeholder='Username'
                name='username'
                value={username}
                onChange={(e) => setUsername(e.target.value)}
                required
              />
              <Form.Control.Feedback>Looks good!</Form.Control.Feedback>
              <Form.Control.Feedback type='invalid'>
                Please enter your username
                </Form.Control.Feedback>
            </Form.Group>
            {/* Password */}
            <Form.Group controlId='loginPassword' className='mb-2'>
              <Form.Control
                type='password'
                placeholder='Password'
                name='password'
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
              />
              <Form.Control.Feedback>Looks good!</Form.Control.Feedback>
              <Form.Control.Feedback type='invalid'>
                Please enter your password
              </Form.Control.Feedback>
            </Form.Group>
            {/* Login Button */}
            <Button
              type='submit'
              className='w-100 btn-lg mb-3 btn'
              onClick={handleSubmit}
              variant="dark"
            >
              Login
            </Button>
          </Form>
          {/* Register User */}
          <small className='text-muted text-center d-block'>
            Not a member yet?
            <Link to='/register' style={{ textDecoration: 'none' }}>
              <span className='register text-primary ml-2 link'>
                Sign up for free
              </span>
            </Link>
          </small>

        </Col>
      </Container>
    </React.Fragment>
  );
}

LoginView.propTypes = {
  user: PropTypes.shape({
    username: PropTypes.string.isRequired,
    pasword: PropTypes.string.isRequired
  }),
  onLoggedIn: PropTypes.func.isRequired,
  onRegister: PropTypes.func
};

const mapDispatchToProps = (dispatch) => ({
  userLoginRequested: () => dispatch(userLoginRequested()),
  loginUser: (username, password) => dispatch(loginUser(username, password)),
});

export default connect(null, mapDispatchToProps)(LoginView);