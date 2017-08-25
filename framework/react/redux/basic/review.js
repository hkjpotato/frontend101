what is a container component

container component is just a glue between the store and the presentational component

Q1: if presentational component is just about rendering
props to UI and listener to event in UI and call the corresponding
callback props. Who make the props? The Container component.

Q2: from where does container component make the props? from store

Q3: traditionally without redux, we can still separate the dump UI from the
stateful component. In that case, stateful component hold the state.
Here in redux, is the container component stateful(hold state)?

from the medium article. This is a hard question.

both presentational and container component can be stateless or stateful.
