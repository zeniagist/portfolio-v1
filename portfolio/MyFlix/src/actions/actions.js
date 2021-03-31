export const SET_MOVIES = 'SET_MOVIES';
export const SET_FILTER = 'SET_FILTER';
export const SET_USER = 'SET_USER';

// initialize movies list
export function setMovies(value) {
  return { type: SET_MOVIES, value };
}

// sets filter for movie list
export function setFilter(value) {
  return { type: SET_FILTER, value };
}

// sets user
export function setUsers(value) {
  return {
    type: SET_USER, value
  }
}