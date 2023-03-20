package main

import "authentication/database"

func main() {
	// load the config
	LoadAppConfig()
	// connect the database and migrate
	database.Connect(AppConfig.ConnectionString)
	database.Migrate()
}
