			library(e1071)
			dataDirectory<-'C:/thesis/attrition/public/simulation-others/data/'
			data<-read.csv(paste(dataDirectory,'all_region.csv',sep=''),header=TRUE)
			model<-svm(Y~X,data)
			predictY<-predict(model,data.frame(X=0.5			))
			predictY