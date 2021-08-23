### Setup
    config .env/docker
    make build
    make generate-ssh-keys (pass)
    make run

### Init
    docker ps
    docker stop traefik id
    make run
    make ssh-be