import React, { useState } from 'react';
import PropTypes from 'prop-types';

import { connect } from 'react-redux';
import { Link } from 'react-router-dom';

import { Form, Button, Container, Col } from 'react-bootstrap';

import './registration-view.scss';
import axios from 'axios';
import Config from '../../config'

export function RegisterView(props) {
  const [username, setUsername] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [birthdate, setBirthdate] = useState('');

  const handleRegister = (e) => {
    e.preventDefault();
    axios.post(`${Config.API_URL}/users`, {
      Username: username,
      Password: password,
      Email: email,
      Birthday: birthdate
    })
      .then(response => {
        const data = response.data;
        console.log(data);
        window.open('/', '_self'); // '_self' is necessary so the page will open in the current tab
        alert('You may now log in');
      })
      .catch(e => {
        console.log('error registering the user')
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
          <h2 className='text-left h6 text-dark font-weight-bold mb-3'>
            Join{' '}
            <span className='font-italic app-name'>
              myFlix
            </span>{' '}
            for free
          </h2>
          {/* Sign up */}
          <Form className='mb-2'>
            {/* Username */}
            <Form.Group className='mb-2' controlId='registerUsername'>
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
                Please choose a username
              </Form.Control.Feedback>
            </Form.Group>
            {/* Email */}
            <Form.Group className='mb-2' controlId='registerEmail'>
              <Form.Control
                type='email'
                placeholder='Email'
                name='email'
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
              />
              <Form.Control.Feedback>Looks good!</Form.Control.Feedback>
              <Form.Control.Feedback type='invalid'>
                Please enter a valid email address
            </Form.Control.Feedback>
            </Form.Group>
            {/* Password */}
            <Form.Group className='mb-2' controlId='registerPassword'>
              <Form.Control
                type='password'
                placeholder='Password'
                name='password'
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
                minLength='7'
              />
              <Form.Control.Feedback>Looks good!</Form.Control.Feedback>
              <Form.Control.Feedback type='invalid'>
                Password must be at least 7 characters
              </Form.Control.Feedback>
            </Form.Group>
            {/* Confirm Password */}
            <Form.Group className='mb-2' controlId='registerConfirmPassword'>
              <Form.Control
                type='password'
                placeholder='Confirm password'
                name='passwordConfirm'
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
                required
                minLength='7'
              />
              <Form.Control.Feedback>Looks good!</Form.Control.Feedback>
              <Form.Control.Feedback type='invalid'>
                Password must be at least 7 characters
              </Form.Control.Feedback>
            </Form.Group>
            {/* Birthday */}
            <Form.Group controlId='registerBirthday' className='mb-2 '>
              <Form.Label className='mb-1 text-muted font-weight-bold'>
                Please enter your birthday
              </Form.Label>
              <Form.Control
                type='date'
                name='birthday'
                placeholder='Birthday'
                value={birthdate}
                onChange={(e) => setBirthdate(e.target.value)}
                required
              />
              <Form.Control.Feedback>Looks good!</Form.Control.Feedback>
              <Form.Control.Feedback type='invalid'>
                Birthday is required
              </Form.Control.Feedback>
            </Form.Group>

            {/* Sign up button */}
            <Button type='submit' className='w-100 btn-lg mb-3' onClick={handleRegister}>
              Sign Up
            </Button>

          </Form>
          <small className='text-muted text-center d-block'>
            Already a member?
            <Link to='/'>
              <span style={{ cursor: 'pointer' }} className='text-primary ml-2'>
                Login here
              </span>
            </Link>
          </small>


        </Col>
      </Container>
      {/* <Form className='register-form'>
        <h1 className='register-header'>Welcome to myFlix!</h1>
        <p className="register-header">
          Login in&nbsp;
          <Link to={`/login`}>here</Link>
        </p>
        <Form.Group controlId='formBasicText'>
          <Form.Label size='lg'>Username</Form.Label>
          <Form.Control
            type='text'
            size='lg'
            value={username}
            onChange={(e) => setUsername(e.target.value)}
            placeholder='Enter usename'
          />
        </Form.Group>
        <Form.Group controlId='formBasicEmail'>
          <Form.Label size='lg'>Email</Form.Label>
          <Form.Control
            type='email'
            size='lg'
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            placeholder='Enter email'
          />
        </Form.Group>
        <Form.Group controlId='formBasicPassword'>
          <Form.Label size='lg'>Password</Form.Label>
          <Form.Control
            type='password'
            size='lg'
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            placeholder='Enter new password'
          />
        </Form.Group>
        <Form.Group controlId='formBasicConfirmPassword'>
          <Form.Label size='lg'>Confirm Password</Form.Label>
          <Form.Control
            type='password'
            size='lg'
            value={confirmPassword}
            onChange={(e) => setConfirmPassword(e.target.value)}
            placeholder='Confirm your password'
          />
        </Form.Group>
        <Form.Group controlId='formBasicDate'>
          <Form.Label size='lg'>Birthdate</Form.Label>
          <Form.Control
            type='date'
            size='lg'
            value={birthdate}
            onChange={(e) => setBirthdate(e.target.value)}
            placeholder='Enter your birthdate'
          />
        </Form.Group>
        <Button type='button' variant='success' onClick={handleRegister}>Submit</Button>
        <br />
        <Link to={`/login`}>
          <Button className='login-button' type='button' variant='dark'>
            Already Registered?
          </Button>
        </Link>
      </Form> */}
    </React.Fragment>
  );
}

RegisterView.propTypes = {
  register: PropTypes.shape({
    username: PropTypes.string.isRequired,
    password: PropTypes.string.isRequired,
    confirmPassword: PropTypes.string.isRequired,
    birthdate: PropTypes.string.isRequired
  }),
  onRegister: PropTypes.func,
};