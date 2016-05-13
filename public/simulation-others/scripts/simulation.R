			library(e1071)
			dataDirectory<-'C:/Users/Joey/Documents/Github+/attrition/public/simulation-others/data/'
				data<-read.csv(paste(dataDirectory,'all_unemployment.csv',sep=''),header=TRUE)
				model<-svm(Y~X,data)
				predictY<-predict(model,data.frame(X=1				))
				predictY