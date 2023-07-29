![write-poetry](https://github.com/giacomo-secchi/write-poetry/assets/13584040/c51ec84c-9f4e-46eb-819d-5d9af34dceec)

Welcome to the WritePoetry Repo on GitHub. Here you can find the source code used in the development of the WritePoetry plugin. You can browse the source, look at open issues, contribute code, and keep tracking of ongoing development.

## Getting Started

To get up and running within the WritePoetry Repo, you will need to make sure that you have installed all of the prerequisites.

### Prerequisites

-   [NVM](https://github.com/nvm-sh/nvm#installing-and-updating): While you can always install Node through other means, we recommend using NVM to ensure you're aligned with the version used by our development teams. The repository contains [an `.nvmrc` file](.nvmrc) which helps ensure you are using the correct version of Node.
-   [Docker](https://docs.docker.com/get-docker/):     `wp-env` is powered by Docker. There are instructions available for installing Docker on [Windows](https://docs.docker.com/desktop/install/windows-install/) (we recommend the WSL2 backend), [macOS](https://docs.docker.com/docker-for-mac/install/), and [Linux](https://docs.docker.com/desktop/install/linux-install/).

Once you've installed all of the prerequisites, you can run the following commands to get everything working.

```bash
# Ensure that you're using the correct version of Node
nvm use
# Install the Node.js packages and dependencies 
npm install
# Start the local environment 
npm run wp-env start
```
Finally, navigate to http://localhost:8888 in your web browser to see WordPress running with the local WritePietry plugin and Twenty Twenty-Child theme running and activated. Default login credentials are username: admin password: password.
